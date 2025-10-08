import '../../style/Home/infoblock.scss'
import Availability from '../../assets/Availability.png';
import Comfort from '../../assets/Comfort.png';
import Savings from '../../assets/Savings.png'
function InfoBlock(){
    return(
        <div className="info-block">
            <div className="info-container">
                <div className="item">
                    <div className="item-img">
                        <img src={Availability} alt=""/>
                    </div>
                    <div className="item-header">
                        <h3>Availability</h3>
                    </div>
                    <div className="item-text">
                        <p>Our vehicles are available whenever you need them – 24/7, with fast booking.</p>
                    </div>
                </div>
                <div className="item">
                    <div className="item-img">
                        <img src={Comfort} alt=""/>
                    </div>
                    <div className="item-header">
                        <h3>Comfort</h3>
                    </div>
                    <div className="item-text">
                        <p>Enjoy a smooth and relaxed ride with clean, modern, and well-equipped vehicles.</p>
                    </div>
                </div>
                <div className="item">
                    <div className="item-img">
                        <img src={Savings} alt=""/>
                    </div>
                    <div className="item-header">
                        <h3>Savings</h3>
                    </div>
                    <div className="item-text">
                        <p>Save money with our flexible pricing and affordable rental options.</p>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default InfoBlock;