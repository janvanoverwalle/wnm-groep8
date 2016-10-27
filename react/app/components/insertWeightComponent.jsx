import React from 'react';
import InsertWeightEntry from '../api/WeightApi';

export default class InsertWeightComponent extends React.Component {
    constructor() {
        super();
        this.insertWeight = this.insertWeight.bind(this);
    }
    componentWillMount() {
        this.setState({});
    }
    insertWeight(ev) {
        ev.preventDefault();
        const date = ev.target['insert-weight-form-date'].value;
        const weight = Number(ev.target['insert-weight-form-weight'].value);
        InsertWeightEntry(1, { weight: weight, date: date }).then(jsonData =>
            this.setState({ message: 'insert gelukt' }));
    }
    render() {
        return (
            <form id="insert-weight-form" onSubmit={this.insertWeight}>
                <input type="date" width="300px" name="insert-weight-form-date" required />
                <input type="number" width="300px" name="insert-weight-form-weight" required />
                <input type="submit" />
                {this.state.message}
            </form>
        )
    }
}
