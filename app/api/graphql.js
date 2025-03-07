import { ApolloServer } from 'apollo-server-micro';
import { PrismaClient } from '@prisma/client';
import { readFileSync } from 'fs';
import { join } from 'path';
import Cors from 'cors';

const prisma = new PrismaClient();

// Read the schema file
const typeDefs = readFileSync(join(process.cwd(), 'graphql', 'schema.graphql'), 'utf8');

// Configure CORS
const cors = Cors({
  methods: ['GET', 'POST', 'OPTIONS'],
});

// Middleware to handle CORS
function runMiddleware(req, res, fn) {
  return new Promise((resolve, reject) => {
    fn(req, res, (result) => {
      if (result instanceof Error) {
        return reject(result);
      }
      return resolve(result);
    });
  });
}

const resolvers = {
  Query: {
    posts: async () => {
      return prisma.post.findMany({
        include: { author: true },
      });
    },
    post: async (_, { id }) => {
      return prisma.post.findUnique({
        where: { id },
        include: { author: true },
      });
    },
    publishedPosts: async () => {
      return prisma.post.findMany({
        where: { published: true },
        include: { author: true },
      });
    },
    userPosts: async (_, { userId }) => {
      return prisma.post.findMany({
        where: { authorId: userId },
        include: { author: true },
      });
    },
  },
  Mutation: {
    createPost: async (_, { title, content, excerpt, authorId }) => {
      return prisma.post.create({
        data: {
          title,
          content,
          excerpt,
          author: { connect: { id: authorId } },
        },
        include: { author: true },
      });
    },
    updatePost: async (_, { id, title, content, excerpt, published }) => {
      return prisma.post.update({
        where: { id },
        data: {
          title,
          content,
          excerpt,
          published,
        },
        include: { author: true },
      });
    },
    deletePost: async (_, { id }) => {
      return prisma.post.delete({
        where: { id },
        include: { author: true },
      });
    },
  },
};

const apolloServer = new ApolloServer({
  typeDefs,
  resolvers,
  context: { prisma },
});

const startServer = apolloServer.start();

export default async function handler(req, res) {
  await runMiddleware(req, res, cors);
  await startServer;

  await apolloServer.createHandler({
    path: '/api/graphql',
  })(req, res);
}

export const config = {
  api: {
    bodyParser: false,
  },
};