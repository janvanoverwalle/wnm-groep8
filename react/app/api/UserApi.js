import ApiUrl from './ApiUrl';

export const GetUser = (userId) => {
    return fetch(`${ApiUrl}/users/${userId}`).then(result => result.json());
};
