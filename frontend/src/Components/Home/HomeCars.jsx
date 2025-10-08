import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faArrowRight } from '@fortawesome/free-solid-svg-icons';
import VehicleCard from '../Vehicle/VehicleCard.jsx'
import '../../style/Home/homecars.scss'
import { vehicleAPI } from '../../services/api.js';
import {useEffect, useState} from "react";
import {Link, NavLink} from "react-router-dom";
function HomeCars(){
    const [vehicles, setVehicles] = useState([]);
    const[loading, setLoading] = useState(true);

    useEffect(() => {
        vehicleAPI.getAll({per_page:6}).then(data=>{
           setVehicles(data.data || []);
           setLoading(false);
        }).catch(err=>{
            console.error('Error: ',err);
            setLoading(false);
        });
    }, []);
    if(loading){
        return <div className="choosecar">Loading vehicles...</div>;
    }
    return(
        <div className="choosecar">
            <div className="container">
                <div className="top">
                    <div className="header">
                        <h2>Choose the car that suits you</h2>
                    </div>
                    <div className="viewall">
                        <Link to="/vehicles">View all<FontAwesomeIcon icon={faArrowRight} /></Link>
                    </div>
                </div>
                <div className="cars">
                    {vehicles.map(vehicle =>(
                        <VehicleCard key={vehicle.id} vehicle={vehicle}/>
                    ))}
                </div>
            </div>
        </div>
    )
}

export  default HomeCars;