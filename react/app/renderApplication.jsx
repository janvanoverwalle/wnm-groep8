import UserInfoComponent from './components/userinfocomponent';
import React from 'react';
import { render } from 'react-dom';
import Store from './store';
import UserHabitsComponent from './components/userHabitsComponent';
import AppNavComponent from './components/appNavComponent';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';


class App extends React.Component {
    componentWillMount() {
        this.state = {appBarTitle: "Dashboard"};
        Store.dispatch({type: 'appbar_title', data: this.state.appBarTitle});
    }

    render() {
        return (
            <div>
                <AppNavComponent />
                <UserInfoComponent />
                <UserHabitsComponent/>
            </div>
        );
    }
}

const renderApplication = () => {
    render(<MuiThemeProvider><App /></MuiThemeProvider>, document.getElementById('applicatie'));
}

export default renderApplication;
