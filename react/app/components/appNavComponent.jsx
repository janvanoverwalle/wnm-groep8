import React from 'react';
import Store from '../store';
import AppBar from 'material-ui/AppBar';
import Drawer from 'material-ui/Drawer';
import MenuItem from 'material-ui/MenuItem';
import { Link } from 'react-router'
import DashboardIcon from 'material-ui/svg-icons/action/dashboard';
import HabitIcon from 'material-ui/svg-icons/action/explore';
import SettingsIcon from 'material-ui/svg-icons/action/settings';
import CaloriesIcon from 'material-ui/svg-icons/action/favorite';
import WeightIcon from 'material-ui/svg-icons/action/assessment';
import injectTapEventPlugin from 'react-tap-event-plugin';


export default class appNavComponent extends React.Component  {

    constructor(props){
        super(props);
        injectTapEventPlugin(); //onTouchTap
        this.state = {open:false};
    }

    componentWillMount() {
        this.state = {appBarTitle: null};
        Store.subscribe(() => {
            this.setState({appBarTitle: Store.getState().appBarTitle});
        });
    }

    handleToggle() { this.setState({open: !this.state.open}); }
    handleClose() { this.setState({open: false}); }

    render() {
        return (
            <div>
                <Drawer
                    docked={false}
                    open={this.state.open}>
                    <MenuItem onTouchTap={this.handleClose.bind(this)} leftIcon={<DashboardIcon/>} containerElement={<Link to={'/dashboard'}></Link>} primaryText={"Dashboard"}></MenuItem>
                    <MenuItem onTouchTap={this.handleClose.bind(this)} leftIcon={<WeightIcon/>} containerElement={<Link to={`/weight`}></Link>} primaryText={'Weight'}></MenuItem>
                    <MenuItem onTouchTap={this.handleClose.bind(this)} leftIcon={<CaloriesIcon/>} containerElement={<Link to={`/calories`}></Link>} primaryText={'Calories'}></MenuItem>
                    <MenuItem onTouchTap={this.handleClose.bind(this)} leftIcon={<HabitIcon/>} containerElement={<Link to={`/habits`}></Link>} primaryText={'Habits'}></MenuItem>
                </Drawer>

                <AppBar   title={this.state.appBarTitle}
                          onLeftIconButtonTouchTap={this.handleToggle.bind(this)} />
            </div>
        );
    }
}