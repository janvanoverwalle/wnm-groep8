/**
 * Created by timothy on 29/10/16.
 */
import React from 'react';
import Store from '../store';
import FloatingActionButton from 'material-ui/FloatingActionButton';
import ContentAdd from 'material-ui/svg-icons/content/add';
import { Link } from 'react-router'

const style = {
    margin: 0,
    top: 'auto',
    right: 20,
    bottom: 20,
    left: 'auto',
    position: 'fixed',
};

export default class floatingButtonComponent extends React.Component {
    componentWillMount() {
        this.state = {buttonLink: null};
        this.unsubscribe = Store.subscribe(() => {
            this.setState({buttonLink: Store.getState().buttonLink});
        });
    }

    componentWillUnmount() {
        this.unsubscribe();
    }

    render() {
        return (
            <FloatingActionButton style={style} disabled={this.props.disabled} containerElement={<Link to={this.state.buttonLink}></Link>}>
                <ContentAdd />
            </FloatingActionButton>
        )
    }
}