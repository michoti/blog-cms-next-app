import { useState } from 'react';
import { useMutation, gql } from '@apollo/client';
import { useRouter } from 'next/router';

const CREATE_POST = gql`
  mutation CreatePost($title: String!, $content: String!, $excerpt: String, $authorId: ID!) {
    createPost(title: $title, content: $content, excerpt: $excerpt, authorId: $authorId) {
      id
      title
    }
  }
`;

export default function CreatePost() {
  const [title, setTitle] = useState('');
  const [content, setContent] = useState('');
  const [excerpt, setExcerpt] = useState('');
  const router = useRouter();

  // Hardcoded author ID for simplicity - in a real app, you'd get this from auth
  const authorId = "user-id-1"; 

  const [createPost, { loading, error }] = useMutation(CREATE_POST, {
    onCompleted: () => {
      router.push('/');
    }
  });

  const handleSubmit = async (e) => {
    e.preventDefault();
    await createPost({ variables: { title, content, excerpt, authorId } });
  };

  return (
    
      Create New Post
      
        
          Title
          <input
            type="text"
            id="title"
            value={title}
            onChange={(e) => setTitle(e.target.value)}
            required
          />
        
        
          Excerpt
          <input
            type="text"
            id="excerpt"
            value={excerpt}
            onChange={(e) => setExcerpt(e.target.value)}
          />
        
        
          Content
          <textarea
            id="content"
            value={content}
            onChange={(e) => setContent(e.target.value)}
            required
            rows="10"
          />
        
        
          {loading ? 'Creating...' : 'Create Post'}
        
        {error && {error.message}}
      
    
  );
}