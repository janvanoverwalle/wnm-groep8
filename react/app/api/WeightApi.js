import ApiUrl from './ApiUrl';

export const InsertWeightEntry = (weightEntry) => {
    const options = {
        method: 'POST',
        headers: new Headers({ 'content-type': 'application/json' }),
        body: JSON.stringify(weightEntry)
    };
    return fetch(`${ApiUrl}/weight`, options).then(result => result.json());
};

export const GetUserWeights = (userId) => {
    return fetch(`${ApiUrl}/users/${userId}/weights`).then(result => result.json());
};