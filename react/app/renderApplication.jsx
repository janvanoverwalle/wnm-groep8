import UserComponent from './components/usercomponent';
import React from 'react';
import { render } from 'react-dom';
import InsertWeightComponent from './components/insertWeightComponent';
import AppNavComponent from './components/appNavComponent';

import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';


class App extends React.Component {
    render() {
        return (
            <div>
                <UserComponent />
            </div>
        );
    }
}

const renderApplication = () => {
    render(<MuiThemeProvider><App /></MuiThemeProvider>, document.getElementById('applicatie'));
}

export default renderApplication;
