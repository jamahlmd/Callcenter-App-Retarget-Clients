
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import configureStore from './store/configureStore';

import Header from './components/Header';
import ListGrid from './components/ListGrid';
import LeadsList from './components/LeadsList';

// import {fetchLists} from './actions/lists';


//Redux
const store = configureStore();

//log empty state
// console.log(store.getState());
//
// store.subscribe( () => {
//     const state = store.getState();
//     console.log(state);
// });

// store.dispatch(fetchLists());



const AppRouter = () => (
    <div>
        <Header/>
        <ListGrid/>
    </div>
);


const jsx = (
    <Provider store={store}>
        <AppRouter/>
    </Provider>
);

if (document.getElementById('root')) {
    ReactDOM.render(jsx, document.getElementById('root'));
}

const Belscherm = () => (
    <div>
        <LeadsList/>
    </div>
);


const bellen = (
    <Provider store={store}>
        <Belscherm/>
    </Provider>
);


if (document.getElementById('bellen')) {
    ReactDOM.render(bellen, document.getElementById('bellen'));
}


setInterval(ajaxCall, 200000); //300000 MS == 5 minutes

function ajaxCall() {
    var xhttp;
    xhttp = new XMLHttpRequest();

    console.log('Refreshed Localhost');

    xhttp.open("GET", "/refresh", true);
    xhttp.send();
}