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