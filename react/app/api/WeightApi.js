import ApiUrl from './ApiUrl';

export const InsertWeight = (weightEntry) => {
    const options = {
        method: 'POST',
        headers: new Headers({ 'content-type': 'application/json' }),
        body: JSON.stringify(weightEntry)
    };
    return fetch(`${ApiUrl}/weights`, options).then(result => result.json());
};

export const GetUserWeights = (userId) => {
    return fetch(`${ApiUrl}/users/${userId}/weights`).then(result => result.json());
};