// resources/js/app.js

// Import the CSS/SCSS file that was compiled by Laravel Mix
import '../sass/app.scss'; // Assuming your main SCSS file is app.scss

import React from 'react';
import ReactDOM from 'react-dom';

// Import your Example component
import Example from './components/Example';

const App = () => {
    return (
        <div className="App">
            <Example />
        </div>
    );
};

// Render the App component into the DOM
ReactDOM.render(<App />, document.getElementById('app'));
