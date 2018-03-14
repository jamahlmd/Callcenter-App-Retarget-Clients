import React from 'react';
import {connect} from 'react-redux';
import {startSetBusy} from '../actions/lists';

const ListItem = (props) => (
    <div className="fade col-md-6">
        <div className="container">
            <div className="row">
                <div className="col-md-10 offset-md-1">
                    <a
                        className={"bellijst-link" + (props.agent ? ' inactiveLink' : '')}
                        href={`bellen/${props.id}`}
                        onClick={ () => props.dispatch(startSetBusy(props.id,agent))}
                    >
                        <div className={"card" + (props.agent ? ' bg-danger' : '')}>
                            <div className="text-center card-header">
                                {props.name}
                            </div>
                            {props.agent ? (
                                <div className="card-body">
                                    <h5 className="card-title">
                                        Bezet door: {props.agent}
                                    </h5>
                                </div>
                            ) : (
                                <div className="card-body">
                                    <h5 className="card-title">
                                        Deze lijst is vrij
                                    </h5>
                                </div>
                            )}
                            <ul className="list-group list-group-flush">
                                <li className={"list-group-item" + (props.agent ? ' bg-danger' : '')}>Sales : {props.sales}</li>
                                <li className={"list-group-item" + (props.agent ? ' bg-danger' : '')}>Reject : {props.rejects}</li>
                            </ul>
                            <div className="card-footer">
                                {props.agent ? (
                                    <button href="#" className="btn btn-lg btn-danger">Bezet!</button>
                                ) : (
                                    <button href="#" className="btn btn-lg btn-primary">Bellen!</button>
                                )}
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
);


export default connect()(ListItem);