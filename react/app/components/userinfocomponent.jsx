import React from 'react';
import {GetUser} from '../api/UserApi';
import Store from '../store';
import {Card, CardHeader} from 'material-ui/Card';
import Avatar from 'material-ui/Avatar';

export default class UserInfoComponent extends React.Component {
    componentWillMount() {
        this.state = {userInfo: 'loading'};
        GetUser(2).then(jsondata => {
            Store.dispatch({type: 'load_userInfo', data: jsondata.name});
        });

        Store.subscribe(() => {
            this.setState({userInfo: Store.getState().userInfo});
        });
    }

    render() {
        return (
        <Card style={{margin: 8}}>
            <CardHeader
                title="Welkom"
                titleStyle={{
                    fontSize: 20,
                }}
                subtitle={this.state.userInfo}
                avatar={<Avatar>{this.state.userInfo.charAt(0)}</Avatar>} />
        </Card>
    )
    }
}
