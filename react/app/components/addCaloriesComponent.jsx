/**
 * Created by timothy on 31/10/16.
 */
import React from 'react';
import {InsertCalories} from '../api/CaloriesApi';
import {Card, CardActions, CardHeader, CardText} from 'material-ui/Card';
import RaisedButton from 'material-ui/RaisedButton';
import DatePicker from 'material-ui/DatePicker';
import TextField from 'material-ui/TextField';
import Store from '../store';
import ApiUser from '../api/ApiUser';
import {hashHistory} from 'react-router';

export default class AddCaloriesComponent extends React.Component {
    componentWillMount() {
        //Set title
        this.state = {appBarTitle: "Add Calories", date: new Date().toJSON(), calories: null};
        Store.dispatch({type: 'appbar_title', data: this.state.appBarTitle});
    }

    _handleDateInput(x, value) {
        var newDate  = new Date(value);
        value = newDate.setHours(newDate.getHours() - newDate.getTimezoneOffset() / 60);
        //JSON changes time of date because of UTC
        //http://stackoverflow.com/questions/1486476/json-stringify-changes-time-of-date-because-of-utc
        this.setState({
            date: new Date(value).toJSON() //Format to database format
        });
    }

    handleAddCalories() {
        if (this.state.calories) {
            InsertCalories([{
                "calories": {
                    "calories": this.state.calories,
                    "date": this.state.date,
                    "user_id": ApiUser
                }
            }]).then(hashHistory.goBack());
        }
    }

    render() {
        return (
            <Card style={{margin: 8}}>
                <CardHeader
                    title="Update Calories"
                    titleStyle={{
                        fontSize: 20,
                    }}
                />
                <CardText>
                    <DatePicker name='dateField' defaultDate={new Date()} onChange={(x, value) => this._handleDateInput(x,value)} />
                    <br />
                    <br />
                    <TextField
                        name='caloriesField'
                        type='number'
                        errorText="This field is required!"
                        onChange={e => this.setState({ calories: e.target.value })}
                    />
                </CardText>
                <CardActions>
                    <RaisedButton onTouchTap={this.handleAddCalories.bind(this)}  label="Add calories" primary={true} />
                </CardActions>
            </Card>
        )
    }
}