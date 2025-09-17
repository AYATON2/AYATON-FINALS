import '../sass/app.scss'; 
import React from 'react';
import ReactDOM from 'react-dom';  // Correct import for React 17

import Example from './components/Example';

const App = () => {
    return (
        <div className="App">
            <Example />
        </div>
    );
};

// React 17 rendering method
ReactDOM.render(<App />, document.getElementById('app'));
