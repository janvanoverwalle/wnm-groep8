/**
 * Created by timothy on 31/10/16.
 */
import ApiUrl from './ApiUrl';

export const InsertCalories = (caloriesEntry) => {
    const options = {
        method: 'POST',
        headers: new Headers({ 'content-type': 'application/json' }),
        body: JSON.stringify(caloriesEntry)
    };
    return fetch(`${ApiUrl}/calories`, options).then(result => result.json());
};

export const GetUserCalories = (userId) => {
    return fetch(`${ApiUrl}/users/${userId}/calories`).then(result => result.json());
};

export const RemoveCalories = (caloriesId) => {
    const options = {
        method: 'DELETE',
        headers: new Headers({ 'content-type': 'application/json' })
    };
    return fetch(`${ApiUrl}/calories/${caloriesId}`, options);
};