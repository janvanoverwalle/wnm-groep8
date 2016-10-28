/**
 * Created by timothy on 28/10/16.
 */
import React from 'react';
import Store from '../store';
import UserInfoComponent from './userinfocomponent';
import UserHabitComponent from './userHabitsComponent';

export default class DashboardComponent extends React.Component {
    componentWillMount() {
        this.state = {appBarTitle: "Dashboard"};
        Store.dispatch({type: 'appbar_title', data: this.state.appBarTitle});
    }

    render() {
        return (
            <div>
                <UserInfoComponent/>
                <UserHabitComponent/>
            </div>
        )
    }
}
