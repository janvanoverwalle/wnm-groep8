/**
 * Created by timothy on 1/11/16.
 */
import React from 'react';
import {GetUserHabitsStatus, UpdateHabitReached} from '../api/HabitApi';
import ApiUser from '../api/ApiUser';
import Store from '../store';
import {Card, CardHeader, CardActions, CardText} from 'material-ui/Card';
import {List, ListItem} from 'material-ui/List';
import ReachedIcon from 'material-ui/svg-icons/action/check-circle';
import NotReachedIcon from 'material-ui/svg-icons/content/remove-circle';
import RaisedButton from 'material-ui/RaisedButton';
import {teal500, red700} from 'material-ui/styles/colors';
import FloatingButtonComponent from './floatingButtonComponent';
import Dialog from 'material-ui/Dialog';
import FlatButton from 'material-ui/FlatButton';
import Checkbox from 'material-ui/Checkbox';

export default class UserHabitsOverviewComponent extends React.Component {
    componentWillMount() {
        this.state = {habits: null, open: false, list: null, updateList: null};
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

    handleOpen(updateList) {
        this.setState({updateList: updateList});
        var list = [];
        for (let item of updateList) {
            var checked = (item.isReached == 1);
            list.push(<ListItem key={item.id} primaryText={item.description}
                                leftCheckbox={<Checkbox defaultChecked={checked} onCheck={(event, check) => {
                                    item.isReached = (check ? 1 : 0);
                                }}/>}/>);
        }
        this.setState({list: list});
        this.setState({open: true});
    }

    handleClose() {
        this.setState({open: false});
        this.setState({list: null});
    }

    handleUpdateHabit() {
        for (let habit of this.state.updateList) {
            var json = [{
                "habit_reached": {
                    "id": habit.id,
                    "is_reached": habit.isReached
                }
            }];
            UpdateHabitReached(json).then(() => {
                GetUserHabitsStatus(ApiUser).then(jsondata => {
                    Store.dispatch({type: 'load_habits', data: jsondata});
                });
            });
        }

        this.setState({open: false});
        this.setState({list: null});
        this.setState({updateList: null});
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

        //Set Daily button
        var disabledButton = false;
        Object.keys(habitList).map(function (key) {
            if (new Date(key).toDateString() == new Date().toDateString()) {
                //Set button link
                disabledButton = true;
            }
        });

        const actions = [
            <FlatButton
                label="Cancel"
                primary={true}
                onTouchTap={this.handleClose.bind(this)}
            />,
            <FlatButton
                label="Save"
                primary={true}
                onTouchTap={this.handleUpdateHabit.bind(this)}
            />,
        ];

        return (
            <div>
                {Object.keys(habitList).map(function (key) {
                    var habits = [];
                    // For Updating
                    var updateList = [];
                    for (let habit of habitList[key]) {
                        updateList.push({"id": habit.id, "description": habit.description, "isReached": habit.isReached})
                        var icon = (habit.isReached == 1 ? <ReachedIcon color={teal500}/> : <NotReachedIcon color={red700}/>);
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
                            <CardText>
                                <List>
                                    {habits}
                                </List>
                            </CardText>
                            <CardActions>
                                <RaisedButton label="Update" primary={true}
                                              onTouchTap={this.handleOpen.bind(this, updateList)}/>
                            </CardActions>
                        </Card>
                    );
                }, this)}
                <div>
                    <Dialog
                        title="Update Habits"
                        actions={actions}
                        modal={true}
                        open={this.state.open}>
                        {this.state.list}
                    </Dialog>
                </div>
                <FloatingButtonComponent disabled={disabledButton} buttonLink={"add-daily-habit"}/>
            </div>
        )
    }
}
