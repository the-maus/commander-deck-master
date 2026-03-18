import "./assets/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "./App.css";
import { BrowserRouter, Route, Routes } from "react-router";
import Navbar from "./components/Navbar";
import Decks from "./pages/Decks";
import NewDeck from "./pages/NewDeck";
import EditDeck from "./pages/EditDeck";
import Login from "./pages/Login";
import { useAuth } from "./context/AuthContext";
import AuthOnly from "./components/auth/AuthOnly";
import GuestOnly from "./components/auth/GuestOnly";

function App() {
    const { user } = useAuth();

    return (
        <>
            <BrowserRouter>
                <Navbar />
                <Routes>
                    {/* guest-only routes */}
                    <Route element={<GuestOnly user={user}/>}>
                        <Route path="/login" element={<Login />} /> 
                    </Route>

                    {/* authenticated-user routes */}
                    <Route element={<AuthOnly user={user} />}>
                        <Route path="/" element={<Decks />} />
                        <Route path="/new-deck" element={<NewDeck />} />
                        <Route
                            path="/edit-deck/:deckId"
                            element={<EditDeck />}
                        />
                    </Route>
                </Routes>
            </BrowserRouter>
        </>
    );
}

export default App;
