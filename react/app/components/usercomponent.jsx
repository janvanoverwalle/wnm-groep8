import React from 'react';
import GetUser from '../api/UserApi';
import Store from '../store';
import {Card, CardHeader, CardText} from 'material-ui/Card';
import Avatar from 'material-ui/Avatar';

export default class UserComponent extends React.Component {
    componentWillMount() {
        this.state = {userInfo: 'loading'};
        GetUser(1).then(jsondata => {
            Store.dispatch({type: 'load_userInfo', data: jsondata.name});
        });

        Store.subscribe(() => {
            this.setState({userInfo: Store.getState().userInfo});
        });
    }

    render() {
        return (
            <Card>
                <CardHeader
                    title="Welkom"
                    subtitle={this.state.userInfo}
                    avatar={<Avatar>{this.state.userInfo.charAt(0)}</Avatar>}
                />
            </Card>
        )
    }
}
