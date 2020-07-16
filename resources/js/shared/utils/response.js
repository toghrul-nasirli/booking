export const is404 = function (error) {
    return isErrorWithResponseAndStatus(error) && error.response.status == 404;
}

export const is422 = function (error) {
    return isErrorWithResponseAndStatus(error) && error.response.status == 422;
}

const isErrorWithResponseAndStatus = function (error) {
    return error.response && error.response.status;
}