import '../../style/Home/hero.scss'
import HeroImage from '../../assets/HeroImage.png';
function Hero(){
    return(
        <div className="hero">
            <div className="hero-container">
                <div className="content">
                    <div className="text">
                        <p className='wlcm-msg'>Welcome to Car Rental</p>
                        <h1>Rent The Best Quality Car's <br/><span>With Us</span></h1>
                        <p>We provide top-notch car rental services with affordable pricing and flexible options. Whether you're going on a trip or need a ride in town — we got you covered.</p>
                    </div>
                    <div className="content-btn">
                        <div className="btn">
                            <a href="#">Book your ride</a>
                        </div>
                    </div>
                </div>
                <div className="image">
                    <div className="heroimage">
                        <img src={HeroImage} alt=""/>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Hero;