import React from 'react';
import { render } from 'react-dom';
import { Router, Route, useRouterHistory, IndexRedirect } from 'react-router';
import createHashHistory from 'history/lib/createHashHistory';
import DashboardComponent from './components/dashboardComponent';
import WeightOverviewComponent from './components/weightOverviewComponent';
import AddWeightComponent from './components/addWeightComponent';
import AppNavComponent from './components/appNavComponent';
import CaloriesOverviewComponent from './components/caloriesOverviewComponent';
import AddCaloriesComponent from './components/addCaloriesComponent';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
export const history = useRouterHistory(createHashHistory)({queryKey:false});

class App extends React.Component {
    render() {
        return (
            <MuiThemeProvider>
                <div>
                    <AppNavComponent />
                    <div>
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
            <IndexRedirect to='dashboard'/>
            <Route path="dashboard" component={DashboardComponent}/>
            <Route path="weight" component={WeightOverviewComponent}/>
            <Route path="addweight" component={AddWeightComponent}/>
            <Route path="calories" component={CaloriesOverviewComponent}/>
            <Route path="addcalories" component={AddCaloriesComponent}/>
        </Route>
    </Router>
    ),document.getElementById('applicatie'));
};

export default renderApplication;
