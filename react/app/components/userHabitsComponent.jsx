import React from 'react';
import {GetUserHabits} from '../api/UserApi';
import ApiUser from '../api/ApiUser';
import Store from '../store';
import {Card, CardHeader} from 'material-ui/Card';
import {List, ListItem} from 'material-ui/List';

export default class UserHabitsComponent extends React.Component {
    componentWillMount() {
        this.state = {userHabits: null};
        GetUserHabits(ApiUser).then(jsondata => {
            Store.dispatch({type: 'load_userHabits', data: jsondata});
        });

        this.unsubscribe = Store.subscribe(() => {
            this.setState({userHabits: Store.getState().userHabits});
        });
    }

    componentWillUnmount() {
        this.unsubscribe();
    }

    render() {
        var habitList = [];
        if (this.state.userHabits != null) {
            for (let habit of this.state.userHabits) {
                habitList.push(<ListItem key={habit.id} primaryText={habit.description}/>);
                //Added key: Each child in an array or iterator should have a unique "key" prop
                //https://facebook.github.io/react/docs/lists-and-keys.html
            }
        }

        return (
            <Card style={{margin: 8}}>
                <CardHeader
                    title="Habits"
                    subtitle="Uw 3 habits"
                    titleStyle={{
                        fontSize: 20,
                    }}
                />
                <List>
                    {habitList}
                </List>
            </Card>
        )
    }
}
