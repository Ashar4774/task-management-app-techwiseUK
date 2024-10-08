import { required, email } from '@vuelidate/validations';

export const validations = {
    name: { required },
    email: { required, email },
    password: { required },
};
