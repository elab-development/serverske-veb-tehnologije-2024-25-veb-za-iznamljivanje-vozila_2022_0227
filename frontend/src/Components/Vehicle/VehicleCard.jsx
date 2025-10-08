import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faGasPump, faGear, faUsers } from '@fortawesome/free-solid-svg-icons';
import { Link } from "react-router-dom";
import '../../style/Vehicle/card.scss'
import Car from '../../assets/car.png'
function VehicleCard({vehicle}){
    return(
        <div className="vehicle-card">
            <div className="image">
                <img src={vehicle.image_full_url} alt=""/>
            </div>
            <div className="top-card">
                <div className="model-type">
                    <p className="brand-model">{vehicle.brand} {vehicle.model}</p>
                    <p className="vehicle-type">{vehicle.vehicle_type}</p>
                </div>
                <div className="price">
                    <p className='price-perday'>{vehicle.price_per_day}&euro;</p>
                    <span>per day</span>
                </div>
            </div>
            <div className="middle-card">
                <div className="tank">
                    <p className='tank-capacity'><FontAwesomeIcon icon={faGasPump}/><span>{vehicle.tank_capacity}</span></p>
                </div>
                <div className="transmission">
                    <p className="transmission-type"><FontAwesomeIcon icon={faGear}/><span>{vehicle.transmission}</span></p>
                </div>
                <div className="seats">
                    <p className="seats-cap"><FontAwesomeIcon icon={faUsers}/><span>{vehicle.seats} people</span></p>
                </div>
            </div>
            <div className="details-btn">
                <Link to={`/vehicles/${vehicle.id}`} state={{ vehicle }}>View Details</Link>
            </div>
        </div>
    )
}

export default VehicleCard;