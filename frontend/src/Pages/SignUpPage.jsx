import '../style/Auth/signup.scss'
import Header from "../Components/Layout/Header.jsx";
function SignUpPage(){
    return(
        <>
            <Header/>
            <div className="container">
                <form className="user-form">
                    <input name="name" placeholder="Full name" required />
                    <input name="email" type="email" placeholder="Email" required />
                    <input name="password" type="password" placeholder="Password" required />
                    <input name="password_confirmation" type="password" placeholder="Confirm password" required />
                    <input name="address" placeholder="Address" required />
                    <input name="phone" placeholder="Phone" required />
                    <input name="drivers_license" placeholder="Driver's license" required />
                    <button type="submit">Sign up</button>
                </form>
            </div>
        </>
    )
}
export default SignUpPage;