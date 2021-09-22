import Owners from './components/Owners.vue';
import OwnerEditViewComponent from "./components/OwnerEditViewComponent";
import Addresses from './components/Addresses.vue';
import AddressEditViewComponent from "./components/AddressEditViewComponent";
import Cars from './components/Cars.vue';
import CarEditViewComponent from './components/CarEditViewComponent';

export const routes = [
    {
        name: 'owners',
        path: '/owners',
        component: Owners
    },
    {
        name: 'owners.editView',
        path: '/owners/:id/:action',
        component: OwnerEditViewComponent
    },
    {
        name: 'addresses',
        path: '/addresses',
        component: Addresses
    },
    {
        name: 'addresses.editView',
        path: '/addresses/:id/:action',
        component: AddressEditViewComponent
    },
    {
        name: 'cars',
        path: '/cars',
        component: Cars
    },
    {
        name: 'cars.editView',
        path: '/cars/:id/:action',
        component: CarEditViewComponent
    },
];
