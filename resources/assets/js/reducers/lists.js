//Lists reducer
//Lists reducer default state
const listsReducerDefaultState = {
    lists: [],
    loading: false,
    error: null
};

//setup Lists reducer

const listsReducer = (state = listsReducerDefaultState, action) => {
    switch(action.type) {
        case "FETCH_LISTS_SUCCESS":
            return {
                ...state,
              loading: false,
              lists: action.lists
            };
        case "FETCH_LISTS_BEGIN":
            return {
                ...state,
                loading: true
            };
        case "FETCH_LISTS_ERROR":
            return {
                ...state,
                loading: false,
                error: action.error
            };
        case "ADD_LIST":
            return {
                ...state,
                lists: state.lists.concat({
                   id: action.list.marketinglist.id,
                   name: action.list.marketinglist.name,
                    agent: action.list.marketinglist.agent,
                    sales: action.list.marketinglist.sales,
                    rejects: action.list.marketinglist.rejects,
                    created_at: action.list.marketinglist.created_at,
                    updated_at: action.list.marketinglist.updated_at,
                })
            };
        case "SET_BUSY":
            const SET_BUSY = state.lists.map( (list) => {
                if(list.id === action.id){
                    return {
                        ...list,
                        agent: action.agent
                    };
                } else {
                    return list;
                }
            });
            return {
                ...state,
                lists: SET_BUSY
            };
        case "SET_NOT_BUSY":
            const SET_NOT_BUSY =  state.lists.map( (list) => {
                if(list.id === action.id){
                    return {
                        ...list,
                        agent: null
                    };
                } else {
                    return list;
                }
            });
            return {
                ...state,
                lists: SET_NOT_BUSY
            };
        default:
            return state;
    }
};


export default listsReducer;