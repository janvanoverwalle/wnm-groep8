/**
 * Created by timothy on 31/10/16.
 */
import React from 'react';
import {GetUserCalories, RemoveCalories} from '../api/CaloriesApi';
import Store from '../store';
import {Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn} from 'material-ui/Table';
import FloatingButtonComponent from './floatingButtonComponent';
import ApiUser from '../api/ApiUser';
import IconMenu from 'material-ui/IconMenu';
import MenuItem from 'material-ui/MenuItem';
import IconButton from 'material-ui/IconButton';
import MoreVertIcon from 'material-ui/svg-icons/navigation/more-vert';

export default class CaloriesOverviewComponent extends React.Component {
    componentWillMount() {
        this.state = {userCalories: null};
        GetUserCalories(ApiUser).then(jsondata => {
            Store.dispatch({type: 'load_userCalories', data: jsondata});
        });

        this.unsubscribe = Store.subscribe(() => {
            this.setState({userCalories: Store.getState().userCalories});
        });

        //Set title
        Store.dispatch({type: 'appbar_title', data: "Calories Overview"});
        //Set button link
        Store.dispatch({type: 'button_link', data: "addcalories"});
    }

    componentWillUnmount() {
        this.unsubscribe();
    }

    componentWillUpdate() {
        GetUserCalories(ApiUser).then(jsondata => {
            Store.dispatch({type: 'load_userCalories', data: jsondata});
        });
    }

    handleRemoveCalories(id) {
        RemoveCalories(id).then(this.componentWillUpdate());
    }

    render() {
        var caloriesList = [];
        if (typeof this.state.userCalories !== 'undefined' && this.state.userCalories.length > 0) {
            for (let calorie of this.state.userCalories) {
                caloriesList.push({ id: calorie.id, calories: calorie.calories, date: calorie.date});
            }
        }

        return (
            <div>
                <Table>
                    <TableHeader displaySelectAll={false}
                                 adjustForCheckbox={false}>
                        <TableRow>
                            <TableHeaderColumn>Date</TableHeaderColumn>
                            <TableHeaderColumn>Calories</TableHeaderColumn>
                            <TableHeaderColumn>Actions</TableHeaderColumn>
                        </TableRow>
                    </TableHeader>
                    <TableBody displayRowCheckbox={false}>
                        {caloriesList.map( (row, index) => (
                            <TableRow key={index}>
                                <TableRowColumn>{row.date}</TableRowColumn>
                                <TableRowColumn>{row.calories}</TableRowColumn>
                                <TableRowColumn>
                                    <IconMenu
                                        iconButtonElement={<IconButton><MoreVertIcon /></IconButton>}
                                        anchorOrigin={{horizontal: 'left', vertical: 'top'}}
                                        targetOrigin={{horizontal: 'left', vertical: 'top'}} >
                                        <MenuItem primaryText="Remove" onTouchTap={this.handleRemoveCalories.bind(this, row.id)} />
                                    </IconMenu>
                                </TableRowColumn>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
                <FloatingButtonComponent/>
            </div>
        )
    }
}
