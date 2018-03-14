import React, { Component } from 'react';
import { connect } from "react-redux";
import ListItem from './ListItem';
import {fetchLists, addList} from '../actions/lists';

class ListGrid extends Component {
    componentDidMount() {
        this.props.dispatch(fetchLists());
        Echo.private(`NewList`)
            .listen('NewList', (e) => {
                this.props.dispatch(addList(e));
            });
    };
    render(){
        const { error, loading, marketinglists } = this.props;

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