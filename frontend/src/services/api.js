const API_URL = 'http://127.0.0.1:8000/api';

export const vehicleAPI = {
    getAll: async (params = {}) => {
        const queryString = new URLSearchParams(params).toString();
        const response = await fetch(`${API_URL}/vehicles?${queryString}`);
        return response.json();
    },

    getById: async (id) => {
        const response = await fetch(`${API_URL}/vehicles/${id}`);
        return response.json();
    },

    getAvailable: async () => {
        const response = await fetch(`${API_URL}/vehicles/available`);
        return response.json();
    },

    search: async (query) => {
        const response = await fetch(`${API_URL}/vehicles/search?q=${query}`);
        return response.json();
    }
};

export const reservationAPI = {
    create: async (data, token) => {
        const response = await fetch(`${API_URL}/reservations`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify(data)
        });
        return response.json();
    },

    getAll: async () => {
        const response = await fetch(`${API_URL}/reservations`);
        return response.json();
    }
};

export const authAPI = {
    login: async (email, password) => {
        const response = await fetch(`${API_URL}/auth/login`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        });
        return response.json();
    },

    register: async (userData) => {
        const response = await fetch(`${API_URL}/auth/register`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(userData)
        });
        return response.json();
    }
};