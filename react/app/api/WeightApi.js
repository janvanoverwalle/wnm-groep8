import ApiUrl from './ApiUrl';

const InsertWeightEntry = (userId, weightEntry) => {
    const options = {
        method: 'POST',
        headers: new Headers({ 'x-user-id': userId, 'content-type': 'application/json' }),
        body: JSON.stringify(weightEntry)
    }
    return fetch(`${ApiUrl}/weight`, options).then(result => result.json());
}

export default InsertWeightEntry;
