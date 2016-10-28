import React from 'react';
import { render } from 'react-dom';
import { Router, Route, useRouterHistory, IndexRedirect } from 'react-router';
import createHashHistory from 'history/lib/createHashHistory';
import Store from './store';
import UserInfoComponent from './components/userinfocomponent';
import UserHabitsComponent from './components/userHabitsComponent';
import AppNavComponent from './components/appNavComponent';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
export const history = useRouterHistory(createHashHistory)({queryKey:false});

class App extends React.Component {
    componentWillMount() {
        this.state = {appBarTitle: "Dashboard"};
        Store.dispatch({type: 'appbar_title', data: this.state.appBarTitle});
    }

    render() {
        return (
            <MuiThemeProvider>
                <div>
                    <AppNavComponent />
                    <div id="router-route">
                        {this.props.children}
                    </div>
                </div>
            </MuiThemeProvider>
        );
    }
}

const renderApplication = () => {
    render((
    <Router history={history}>
        <Route path="/" component={App}>
            <IndexRedirect to='userinfo'/>
            <Route path="userinfo" component={UserInfoComponent}/>
            <Route path="habit" component={UserHabitsComponent}/>
        </Route>
    </Router>
    ),document.getElementById('applicatie'));
};

export default renderApplication;
