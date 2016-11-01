/**
 * Created by timothy on 1/11/16.
 */
import React from 'react';
import {GetUserHabitsStatus} from '../api/HabitApi';
import ApiUser from '../api/ApiUser';
import Store from '../store';
import {Card, CardHeader, CardActions} from 'material-ui/Card';
import {List, ListItem} from 'material-ui/List';
import ReachedIcon from 'material-ui/svg-icons/action/check-circle';
import NotReachedIcon from 'material-ui/svg-icons/content/remove-circle';
import RaisedButton from 'material-ui/RaisedButton';
import {teal500, red700} from 'material-ui/styles/colors'

export default class UserHabitsOverviewComponent extends React.Component {
    componentWillMount() {
        this.state = {habits: null};
        GetUserHabitsStatus(ApiUser).then(jsondata => {
            Store.dispatch({type: 'load_habits', data: jsondata});
        });

        this.unsubscribe = Store.subscribe(() => {
            this.setState({habits: Store.getState().habits});
        });

        //Set title
        Store.dispatch({type: 'appbar_title', data: "Habits Overview"});
    }

    componentWillUnmount() {
        this.unsubscribe();
    }

    render() {
        var habitList = [];
        if (this.state.habits != null) {
            habitList = this.state.habits.reduce(function (result, current) {
                result[current.date] = result[current.date] || [];
                result[current.date].push(current);
                return result;
            }, []);
        }

        return (
            <div>
                {Object.keys(habitList).map(function (key) {
                    var habits = [];
                    for (let habit of habitList[key]) {
                        var icon = (habit['isReached'] == 0 ? <ReachedIcon color={teal500}/> : <NotReachedIcon color={red700}/>);
                        habits.push(<ListItem key={habit.id} primaryText={habit.description} leftIcon={icon}/>);
                    }
                    return (
                    <Card style={{margin: 8}} key={key}>
                        <CardHeader
                            title={new Date(key).toDateString()}
                            titleStyle={{
                                fontSize: 20,
                            }}
                        />
                        <List>
                            {habits}
                        </List>
                        <CardActions>
                            <RaisedButton label="Update" primary={true}/>
                        </CardActions>
                    </Card>
                    );
                }, this)}
            </div>
        )
    }
}
