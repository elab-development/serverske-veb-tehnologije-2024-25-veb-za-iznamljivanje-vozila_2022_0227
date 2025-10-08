import Header from '../Components/Layout/Header.jsx';
import InfoBlock from '../Components/Home/InfoBlock.jsx';
import Hero from "../Components/Home/Hero.jsx";
import HomeCars from "../Components/Home/HomeCars.jsx"
function HomePage(){
    return(
        <>
            <Header/>
            <Hero/>
            <InfoBlock/>
            <HomeCars/>
        </>
    );
}
export default HomePage;