import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {
    faGear,
    faGasPump,
    faCar,
    faUsersRays,
    faIdCard
} from '@fortawesome/free-solid-svg-icons';
import { vehicleAPI } from "../../services/api.js";
import '../../style/Vehicle/details.scss'
import {useEffect, useState} from "react"
import { useLocation, useParams } from "react-router-dom";
function VehicleDetails(){
    const { id } = useParams();
    const location = useLocation();
    const fromState = location.state?.vehicle || null;
    const [vehicle, setVehicle] = useState(fromState);
    const [loading, setLoading] = useState(!fromState);
    const[error,setError]=useState(null);
    useEffect(() => {
        if (fromState) return; // već imamo sve

        let mounted = true;
        setLoading(true);
        setError(null);

        vehicleAPI.getById(id)
            .then((data) => {
                if (!mounted) return;
                // ako tvoj API vraća { data: {...} } umesto direktnog objekta:
                const v = data?.data ?? data;
                setVehicle(v);
            })
            .catch((e) => {
                if (!mounted) return;
                setError("Failed to load vehicle.");
                console.error(e);
            })
            .finally(() => { if (mounted) setLoading(false); });

        return () => { mounted = false; };
    }, [id, fromState]);
    if (loading) return <div className="vehicle-details">Loading...</div>;
    if (error)   return <div className="vehicle-details">{error}</div>;
    if (!vehicle) return <div className="vehicle-details">Not found</div>;
    return(
        <div className="vehicle-details">
            <div className="left-side">
                <div className="ls-top">
                    <h2>{vehicle.brand} {vehicle.model}</h2>
                    <p>{vehicle.price_per_day} €</p>
                </div>
                <div className="ls-image">
                    <img src={vehicle.image_full_url} width='600px' alt="BMW"/>
                </div>
            </div>
            <div className="right-side">
                <h2>Technical Specification</h2>
                <div className="items">
                    <div className="item">
                        <div><FontAwesomeIcon icon={faGear} /></div>
                        <h4>Gear Box</h4>
                        <p>{vehicle.transmission}</p>
                    </div>
                    <div className="item">
                        <div><FontAwesomeIcon icon={faGasPump} /></div>
                        <h4>Fuel</h4>
                        <p>{vehicle.fuel_type}</p>
                    </div>
                    <div className="item">
                        <div><FontAwesomeIcon icon={faGasPump} /></div>
                        <h4>Tank capacity</h4>
                        <p>{vehicle.tank_capacity}</p>
                    </div>
                    <div className="item">
                        <div><FontAwesomeIcon icon={faCar} /></div>
                        <h4>Vehicle type</h4>
                        <p>{vehicle.vehicle_type}</p>
                    </div>
                    <div className="item">
                        <div><FontAwesomeIcon icon={faUsersRays} /></div>
                        <h4>Seats</h4>
                        <p>{vehicle.seats}</p>
                    </div>
                    <div className="item">
                        <div><FontAwesomeIcon icon={faIdCard} /></div>
                        <h4>Plate number</h4>
                        <p>{vehicle.plate_number}</p>
                    </div>
                </div>
                <div className="reservation-btn">
                    <a href="#">Reserve</a>
                </div>
            </div>
        </div>
    )
}
export default VehicleDetails;