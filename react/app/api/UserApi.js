import ApiUrl from './ApiUrl';

export const GetUser = (userId) => {
    return fetch(`${ApiUrl}/users/${userId}`).then(result => result.json());
};

export const GetUserHabits = (userId) => {
    return fetch(`${ApiUrl}/users/${userId}/habits`).then(result => result.json());
};

