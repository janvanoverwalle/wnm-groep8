/**
 * Created by timothy on 28/10/16.
 */
import React from 'react';
import {GetUserWeights, RemoveWeight} from '../api/WeightApi';
import Store from '../store';
import {Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn} from 'material-ui/Table';
import FloatingButtonComponent from './floatingButtonComponent';
import ApiUser from '../api/ApiUser';
import IconMenu from 'material-ui/IconMenu';
import MenuItem from 'material-ui/MenuItem';
import IconButton from 'material-ui/IconButton';
import MoreVertIcon from 'material-ui/svg-icons/navigation/more-vert';

export default class WeightOverviewComponent extends React.Component {
    componentWillMount() {
        this.state = {userWeights: null};
        GetUserWeights(ApiUser).then(jsondata => {
            Store.dispatch({type: 'load_userWeights', data: jsondata});
        });

        this.unsubscribe = Store.subscribe(() => {
            this.setState({userWeights: Store.getState().userWeights});
        });

        //Set title
        Store.dispatch({type: 'appbar_title', data: "Weight Overview"});
        //Set button link
        Store.dispatch({type: 'button_link', data: "addweight"});
    }

    componentWillUnmount() {
        this.unsubscribe();
    }

    componentWillUpdate() {
        GetUserWeights(ApiUser).then(jsondata => {
            Store.dispatch({type: 'load_userWeights', data: jsondata});
        });
    }

    handleRemoveWeight(id) {
        RemoveWeight(id).then(this.componentWillUpdate());
    }

    render() {
        var weightList = [];
        if (typeof this.state.userWeights !== 'undefined' && this.state.userWeights.length > 0) {
            for (let weight of this.state.userWeights) {
                weightList.push({ id: weight.id, weight: weight.weight, date: weight.date});
            }
        }

        return (
            <div>
            <Table>
                <TableHeader displaySelectAll={false}
                             adjustForCheckbox={false}>
                    <TableRow>
                        <TableHeaderColumn>Date</TableHeaderColumn>
                        <TableHeaderColumn>Weight</TableHeaderColumn>
                        <TableHeaderColumn>Actions</TableHeaderColumn>
                    </TableRow>
                </TableHeader>
                <TableBody displayRowCheckbox={false}>
                    {weightList.map( (row, index) => (
                        <TableRow key={index}>
                            <TableRowColumn>{row.date}</TableRowColumn>
                            <TableRowColumn>{row.weight}</TableRowColumn>
                            <TableRowColumn>
                                <IconMenu
                                iconButtonElement={<IconButton><MoreVertIcon /></IconButton>}
                                anchorOrigin={{horizontal: 'left', vertical: 'top'}}
                                targetOrigin={{horizontal: 'left', vertical: 'top'}} >
                                    <MenuItem primaryText="Remove" onTouchTap={this.handleRemoveWeight.bind(this, row.id)} />
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
