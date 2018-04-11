import {createStore, combineReducers, applyMiddleware, compose} from 'redux';
import listsReducer from '../reducers/lists';
import usersReducer from '../reducers/users';
import thunk from 'redux-thunk';


const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;



//Store Creation
//combine reducers in object
export default () => {
    const store = createStore(
    combineReducers({
            listsData: listsReducer,
            usersData: usersReducer
        }),
        composeEnhancers(applyMiddleware(thunk))
    );

    return store;
};
