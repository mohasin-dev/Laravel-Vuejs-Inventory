class Helper
{
    storeToken(token)
    {
        localStorage.setItem('token', token)
    }

    storeUser(user)
    {
        localStorage.setItem('user', user)
    }

    store(user, token)
    {
        this.storeUser(user)
        this.storeToken(token)
    }

    getToken()
    {
        return localStorage.getItem('token')
    }

    getUser()
    {
        return localStorage.getItem('user')
    }

    clear()
    {
        localStorage.removeItem('user')
        localStorage.removeItem('token')
    }

    isValid(token)
    {
        const payload = this.payload(token);
        if (payload) {
            // window.location.host;
            return 'http://127.0.0.1:8000/api/auth/login' || 'http://127.0.0.1:8000/api/auth/signup' ? true : false;
        }

        return false;
    }

    payload(token)
    {
        const payload = token.split('.')[1];

        return this.decode(payload);
    }

    decode(payload)
    {
        return JSON.parse(atob(payload));
    }

    responseAfterLogin(response)
    {
        const access_token = response.data.access_token;
        const userName = response.data.name;
        
        if (this.isValid(access_token)) {
            this.store(userName, access_token);
        }
    }

    hasToken()
    {
        let token = this.getToken();

        if (token) {
            return this.isValid(token) ? true : false;
        }

        return false;
    }

    loggedIn()
    {
        return this.hasToken()
    }

    logout()
    {
        this.clear();
    }

    name()
    {
        if(this.loggedIn()) {
            return this.getUser();
        }

        return false;
    }

    id() 
    {
        if(this.loggedIn()) {
            let payload = this.payload(this.getToken());

            return payload.sub;
        }

        return false;
    }
}

export default Helper = new Helper;