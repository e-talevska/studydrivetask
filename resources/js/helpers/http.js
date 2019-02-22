import axios from 'axios'
import { eventHub } from './eventhub'

const DEFAULT_HEADERS = {
    'Content-Type': 'application/json'
}

const validStatuses = [
    200, 201, 202, 203, 204,
    300, 301, 302, 303, 304
]

axios.interceptors.request.use(
    conf => {
        eventHub.$emit('before-request');
        return conf;
    },
    error => {
        eventHub.$emit('request-error');
        return Promise.reject(error);
    }
);
axios.interceptors.response.use(
    response => {
        eventHub.$emit('after-response');
        return response;
    },
    error => {
        eventHub.$emit('response-error');
        return Promise.reject(error);
    }
);

/*
 * Returns default headers list
 * which will be used with every request.
 */
function getHeaders(multipart = false) {
    let defaultHeaders = DEFAULT_HEADERS

    if (multipart) {
        defaultHeaders = {}
    }

    if (localStorage.jwt) {
        defaultHeaders = {
            'Authorization': `Bearer ${localStorage.jwt}`,
            ...defaultHeaders
        }
    }

    return defaultHeaders
}

let isError = function(e){
    return e && e.stack && e.message;
}

export function checkResponse(response) {

    if (isError(response)) {
        var error = response;
        response = error.response;
    }

    if (validStatuses.includes(response.status)) {
        return Promise.resolve(response)
    }

    // If not authorized then reset token
    // and redirect to login page
    if (response.status === 401) {
        localStorage.removeItem('jwt')
        localStorage.removeItem('user')
        // return Promise.reject(new Error('USER_ANONYMOUS'))
        this.$router.go('/login')
    }

    return error ? Promise.reject(error) : Promise.reject(new Error(response.status))
}

export function processAPIErrors(apiErrors) {
    let errors = {}

    if (apiErrors) {
        for (let key of Object.keys(apiErrors)) {
            let err = apiErrors[key]

            errors[key] = err

            if (typeof err === Object || err.hasOwnProperty('length')) {
                errors[key] = apiErrors[key][0]
            }
        }
    }

    return errors
}

export const esc = encodeURIComponent

export function qs(params) {
    return (
        Object
            .keys(params)
            .map(k => esc(k) + '=' + esc(params[k]))
            .join('&')
    )
}

/*
 * Wraps axios and provides
 * more convenient post method
 * calls with data
 */
export function post(uri, data) {
    return axios.post(uri, data, {
        headers: getHeaders(),
        withCredentials: true
    })
}

/*
 * Wraps axios and provides
 * more convenient put method
 * calls with data
 */
export function put(uri, data) {
    return axios.put(uri, data, {
        headers: getHeaders(),
        withCredentials: true
    })
}

/*
 * Wraps axios and provides
 * more convenient delete method
 */
export function remove(uri) {
    return axios.delete(uri, {
        headers: getHeaders(),
        withCredentials: true
    })
}

/*
 * Wraps axios and provides
 * more convenient get method
 * calls with data.
 */
export function get(uri, data = {}) {
    if (Object.keys(data).length > 0) {
        uri = `${uri}?${qs(data)}`
    }

    return axios.get(uri, {
        headers: getHeaders(),
        withCredentials: true
    })
}

export function upload(uri, data) {
    return fetch(uri, {
        headers: getHeaders(true),
        cors: true,
        method: 'POST',
        body: data
    })
}

// Means endpoint
export function e(uri) {
    return BASE_URL + uri
}
