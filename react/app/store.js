import { createStore } from 'redux';

const reducer = (state, action) => {
    switch (action.type) {
        case 'load_userInfo':
            return Object.assign({}, state, { userInfo: action.data });
        case 'weight_inserted':
            return Object.assign({}, state, { weight: action.data });
        case 'load_userHabits':
            return Object.assign({}, state, { userHabits: action.data});
        case 'appbar_title':
            return Object.assign({}, state, { appBarTitle: action.data});
        default:
            return state;
    }
};

const store = createStore(reducer, {});

export default store;
