import { useQuery, gql } from '@apollo/client';
import Link from 'next/link';

const GET_POSTS = gql`
  query {
    posts {
      id
      title
      excerpt
      published
      createdAt
      author {
        name
      }
    }
  }
`;

export default function Posts() {
  const { loading, error, data } = useQuery(GET_POSTS);

  if (loading) return Loading...;
  if (error) return Error: {error.message};

  return (
    
      Blog Posts
      
        Create New Post
      
      
        {data.posts.map((post) => (
          
            {post.title}
            {post.excerpt}
            By {post.author.name} on {new Date(post.createdAt).toLocaleDateString()}
            
              
                Read More
              
              
                Edit
              
            
            
              {post.published ? 'Published' : 'Draft'}
            
          
        ))}
      
    
  );
}