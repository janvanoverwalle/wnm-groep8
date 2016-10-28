/**
 * Created by timothy on 28/10/16.
 */
import React from 'react';
import {GetUserWeights} from '../api/WeightApi';
import Store from '../store';
import {Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn} from 'material-ui/Table';

export default class WeightOverviewComponent extends React.Component {
    componentWillMount() {
        this.state = {userWeights: null};
        GetUserWeights(1).then(jsondata => {
            Store.dispatch({type: 'load_userWeights', data: jsondata});
        });

        this.unsubscribe = Store.subscribe(() => {
            this.setState({userWeights: Store.getState().userWeights});
        });
    }

    componentWillUnmount() {
        this.unsubscribe();
    }

    render() {
        var weightList = [];
        if (this.state.userWeights != null) {
            for (let weight of this.state.userWeights) {
                weightList.push({ id: weight.id, weight: weight.weight, date: weight.date});
            }
        }

        return (
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHeaderColumn>Date</TableHeaderColumn>
                        <TableHeaderColumn>Weight</TableHeaderColumn>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    {weightList.map( (row, index) => (
                        <TableRow key={index}>
                            <TableRowColumn>{row.date}</TableRowColumn>
                            <TableRowColumn>{row.weight}</TableRowColumn>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        )
    }
}
