/**
 * Created by timothy on 31/10/16.
 */
import ApiUrl from './ApiUrl';

export const GetUserHabits = (userId) => {
    return fetch(`${ApiUrl}/users/${userId}/habits`).then(result => result.json());
};

export const GetUserHabitsStatus = (userId) => {
    return fetch(`${ApiUrl}/users/${userId}/habits/status`).then(result => result.json());
};

export const InsertHabitReached = (habitEntry) => {
    const options = {
        method: 'POST',
        headers: new Headers({ 'content-type': 'application/json' }),
        body: JSON.stringify(habitEntry)
    };
    return fetch(`${ApiUrl}/habits/status`, options).then(result => result.json());
};

export const UpdateHabitReached = (habitEntry) => {
    const options = {
        method: 'PUT',
        headers: new Headers({ 'content-type': 'application/json' }),
        body: JSON.stringify(habitEntry)
    };
    return fetch(`${ApiUrl}/habits/status`, options).then(result => result.json());
};