import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Home from './Pages/HomePage.jsx';
import VehicleDetailsPage from "./Pages/VehicleDetailsPage.jsx";
import SignUpPage from './Pages/SignUpPage.jsx'
import './style/main.scss';
function App() {
    return(
        <BrowserRouter>
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="/vehicles/:id" element={<VehicleDetailsPage/>} />
                <Route path="/signup" element={<SignUpPage/>} />
            </Routes>
        </BrowserRouter>
    );
}

export default App
