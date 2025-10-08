import '../../style/Layout/header.scss'
import { Link, NavLink } from "react-router-dom";
import CarLogo from '../../assets/CarLogo.png';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faRightToBracket, faUserPlus } from '@fortawesome/free-solid-svg-icons';

function Header(){
    return(
        <div className='header'>
            <div className='header-container'>
                <div className='header-logo'>
                    <div className='logo-img'>
                        <Link to="/"><img src={CarLogo} alt="Logo"/></Link>
                    </div>
                    <div className="logo-text">
                        <Link to="/">Car rental</Link>
                    </div>
                </div>
                <div className='header-navbar'>
                    <div className='navbar'>
                        <ul>
                            <li><NavLink to="/">Home</NavLink></li>
                            <li><NavLink to="/vehicles">Vehicles</NavLink></li>
                            <li><NavLink to="/about">About us</NavLink></li>
                            <li><NavLink to="/contact">Contact us</NavLink></li>
                        </ul>
                    </div>
                </div>
                <div className='header-auth'>
                    <div className='auth'>
                        <div className='auth-signup'>
                            <NavLink to="/signup"><FontAwesomeIcon icon={faUserPlus} /><span>Sign up</span></NavLink>
                        </div>
                        <div className="auth-signin">
                            <NavLink to="/signin"><FontAwesomeIcon icon={faRightToBracket} /><span>Sign in</span></NavLink>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Header;