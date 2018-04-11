import React, {Component} from 'react';
import { connect } from 'react-redux';
import Beforeunload from 'react-beforeunload';
import {startSetNotBusy} from '../actions/lists';


class LeadsList extends Component {
    constructor(props){
        super(props);
        this.confirmWinClose = this.confirmWinClose.bind(this);
    }
    confirmWinClose() {
        this.props.dispatch(startSetNotBusy(id));
    }
    render(){
        return (
            <Beforeunload onBeforeunload={this.confirmWinClose}>
                <div>
                    yeahyeah
                </div>
            </Beforeunload>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        marketinglists: state
    };
};

export default connect(mapStateToProps)(LeadsList);






