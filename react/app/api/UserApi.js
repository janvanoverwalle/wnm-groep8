import ApiUrl from './ApiUrl';

const GetUser = (userId) => {
    return fetch(`${ApiUrl}/users/${userId}`).then(result => result.json());
};

export default GetUser;
