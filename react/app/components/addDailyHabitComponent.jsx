/**
 * Created by timothy on 2/11/16.
 */
import React from 'react';
import {GetUserHabits, InsertHabitReached, GetUserHabitsStatus} from '../api/HabitApi';
import {Card, CardActions, CardHeader, CardText} from 'material-ui/Card';
import {List, ListItem} from 'material-ui/List';
import Checkbox from 'material-ui/Checkbox';
import RaisedButton from 'material-ui/RaisedButton';
import Store from '../store';
import ApiUser from '../api/ApiUser';
import {hashHistory} from 'react-router';

export default class AddDailyHabitComponent extends React.Component {
    componentWillMount() {
        this.state = {appBarTitle: "Daily Habit", date: new Date(), userHabits: null, isReached: []};
        GetUserHabits(ApiUser).then(jsondata => {
            Store.dispatch({type: 'load_userHabits', data: jsondata});
        });

        this.unsubscribe = Store.subscribe(() => {
            this.setState({userHabits: Store.getState().userHabits});
        });

        //Set title
        Store.dispatch({type: 'appbar_title', data: this.state.appBarTitle});
    }

    componentWillUnmount() {
        this.unsubscribe();
    }

    handleAddDailyHabit() {
        var data = Store.getState().habits;
        for (let habit of this.state.userHabits) {
            var json = [{
                "habit_reached": {
                    "habit_id": habit.id,
                    "user_id": ApiUser,
                    "date": this.state.date.toJSON(),
                    "is_reached": this.state.isReached[habit.id]
                }
            }];
            InsertHabitReached(json).then(data.push(json));
        }
        Store.dispatch({type: 'load_habits', data: data});
        hashHistory.goBack();
    }

    handleCheckBoxToggle(id) {
        this.state.isReached[id] = (this.state.isReached[id] == 0 ? 1 : 0);
    }

    render() {
        var habitList = [];
        if (this.state.userHabits != null) {
            for (let habit of this.state.userHabits) {
                this.state.isReached[habit.id] = 0;
                habitList.push(<ListItem key={habit.id} primaryText={habit.description} leftCheckbox={<Checkbox onTouchTap={this.handleCheckBoxToggle.bind(this, habit.id)}/>}/>);
                //Added key: Each child in an array or iterator should have a unique "key" prop
                //https://facebook.github.io/react/docs/lists-and-keys.html
            }
        }

        return (
            <Card style={{margin: 8}}>
                <CardHeader
                    title={this.state.date.toDateString()}
                    titleStyle={{
                        fontSize: 20,
                    }}
                />
                <CardText>
                    <List>
                        {habitList}
                    </List>
                </CardText>
                <CardActions>
                    <RaisedButton onTouchTap={this.handleAddDailyHabit.bind(this)} label="Save" primary={true}/>
                </CardActions>
            </Card>
        )
    }
}