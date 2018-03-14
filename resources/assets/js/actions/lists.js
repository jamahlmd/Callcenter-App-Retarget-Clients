export const fetchListsSucces = (lists) => ({
    type: 'FETCH_LISTS_SUCCESS',
    lists
});
export const fetchListsBegin = () => ({
    type: 'FETCH_LISTS_BEGIN'
});
export const fetchListsError = (error) => ({
    type: 'FETCH_LISTS_ERROR',
    error
});

export const fetchLists = () => {
  return dispatch => {
      dispatch(fetchListsBegin());
      fetch('api/lists')
          .then(handleErrors)
          .then(response => {
              return response.json();
          })
          .then(marketinglists => {
              dispatch(fetchListsSucces(marketinglists));
          })
          .catch(error => dispatch(fetchListsError(error)));
  }
};

const handleErrors = (response) => {
    if (!response.ok) {
        throw Error(response.statusText);
    }
    return response;
};


export const addList = (list) => ({
    type: "ADD_LIST",
    list
});


export const setBusy = (id,agent) => ({
    type: 'SET_BUSY',
    id,
    agent
});


export const setNotBusy = (id) => ({
    type: 'SET_NOT_BUSY',
    id
});


export const startSetBusy = (id,agent) => {
    return (dispatch) => {
        dispatch(setBusy(id,agent));
        fetch(`api/lists/${id}`, {
            method: 'put',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({agent})
        }).then( response => {
            return response.json();
        }).then( (data)=> {
            console.log(data);
        }).catch( ()=> {
            console.log('no g');
        });

    }
};


export const startSetNotBusy = (id) => {
    return dispatch => {
        dispatch(setNotBusy(id));
        fetch(`api/lists/${id}`, {
            method: 'put',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({agent : null})
        }).then( response => {
            return response.json();
        }).then( (data)=> {
            console.log(data);
        }).catch( ()=> {
            console.log('no g');
        });
    }
};