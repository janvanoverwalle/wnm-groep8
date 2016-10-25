import { createStore } from 'redux';

const reducer = (state, action) => {
    switch (action.type) {
        case 'load_userInfo':
            return Object.assign({}, state, { userInfo: action.data });
        case 'weight_inserted':
            return Object.assign({}, state, { weight: action.data });
        default:
            return state;
    }
}

const store = createStore(reducer, {});

export default store;
