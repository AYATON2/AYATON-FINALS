import React from 'react';
import ReactDOM from 'react-dom';
import ContactForm from './example';

document.addEventListener('DOMContentLoaded', () => {
  const rootElement = document.getElementById('root');
  if (rootElement) {
    ReactDOM.render(<ContactForm />, rootElement);
  }
});
