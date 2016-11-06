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
    render() {
        return (
            <FloatingActionButton style={style} disabled={this.props.disabled} containerElement={<Link to={this.props.buttonLink}></Link>}>
                <ContentAdd />
            </FloatingActionButton>
        )
    }
}