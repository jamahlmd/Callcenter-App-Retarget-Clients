import {createStore, combineReducers, applyMiddleware} from 'redux';
import listsReducer from '../reducers/lists';
import usersReducer from '../reducers/users';
import thunk from 'redux-thunk';




//Store Creation
//combine reducers in object
export default () => {
    const store = createStore(
    combineReducers({
            listsData: listsReducer,
            usersData: usersReducer
        }),
        window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__(),
        applyMiddleware(thunk)
    );

    return store;
};
