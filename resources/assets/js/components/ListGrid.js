import React, { Component } from 'react';
import { connect } from "react-redux";
import ListItem from './ListItem';
import {fetchLists, addList, setBusy, setNotBusy} from '../actions/lists';

class ListGrid extends Component {
    componentDidMount() {
        this.props.dispatch(fetchLists());
        Echo.private(`NewList`)
            .listen('NewList', (e) => {
                this.props.dispatch(addList(e));
            });

        Echo.private(`setBusy`)
            .listen('setBusy', (e) => {
                this.props.dispatch(setBusy(e.id,e.agent));
            });

        Echo.private(`setNotBusy`)
            .listen('setNotBusy', (e) => {
                this.props.dispatch(setNotBusy(e.id));
            });

    };
    render(){
        const { error, loading, marketinglists } = this.props;

        console.log(marketinglists);

        if (error) {
            return <div>Error! {error.message}</div>;
        }

        if (loading) {
            return <div className="text-center"><img src="https://resellivit.dev/img/Loading_icon.gif"></img></div>;
        }

        return (
            <div className="container-fluid">
                <div className="row">
                    {marketinglists.map( (cur) => <ListItem key={cur.id} {...cur} /> )}
                </div>
            </div>
        )
    }
}

const mapStateToProps = (state) => {
    return {
        marketinglists: state.listsData.lists,
        error: state.listsData.error,
        loading: state.listsData.loading
    };
};

export default connect(mapStateToProps)(ListGrid);