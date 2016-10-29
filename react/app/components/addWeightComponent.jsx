/**
 * Created by timothy on 29/10/16.
 */
import React from 'react';
import {InsertWeight} from '../api/WeightApi';
import {Card, CardActions, CardHeader, CardText} from 'material-ui/Card';
import RaisedButton from 'material-ui/RaisedButton';
import DatePicker from 'material-ui/DatePicker';
import TextField from 'material-ui/TextField';
import Store from '../store';
import ApiUser from '../api/ApiUser';
import {browserHistory} from 'react-router';

export default class AddWeightOverviewComponent extends React.Component {
    componentWillMount() {
        //Set title
        this.state = {appBarTitle: "Add Weight", date: new Date().toJSON(), weight: null};
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

    handleAddWeight() {
        if (this.state.weight) {
            InsertWeight([{
                "weight": {
                    "weight": this.state.weight,
                    "date": this.state.date,
                    "user_id": ApiUser
                }
            }]).then(browserHistory.goBack());
        }
    }

    render() {
        return (
            <Card style={{margin: 8}}>
                <CardHeader
                    title="Update Weight"
                    titleStyle={{
                        fontSize: 20,
                    }}
                />
                <CardText>
                    <DatePicker name='dateField' defaultDate={new Date()} onChange={(x, value) => this._handleDateInput(x,value)} />
                    <br />
                    <br />
                    <TextField
                        name='weightField'
                        type='number'
                        errorText="This field is required!"
                        onChange={e => this.setState({ weight: e.target.value })}
                    />
                </CardText>
                <CardActions>
                    <RaisedButton onTouchTap={this.handleAddWeight.bind(this)}  label="Add weight" primary={true} />
                </CardActions>
            </Card>
        )
    }
}