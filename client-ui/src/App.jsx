import "./assets/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "./App.css";
import { BrowserRouter, Route, Routes } from "react-router";
import Navbar from "./components/Navbar";
import Decks from "./pages/Decks";
import NewDeck from "./pages/NewDeck";
import EditDeck from "./pages/EditDeck";
import Login from "./pages/Login";
import AuthOnly from "./components/auth/AuthOnly";
import GuestOnly from "./components/auth/GuestOnly";

function App() {
    return (
        <>
            <BrowserRouter>
                <Navbar/>
                <Routes>
                    {/* guest routes */}
                    <Route element={<GuestOnly />}>
                        <Route path="/login" element={<Login />} />
                    </Route>

                    {/* authenticated routes */}
                    <Route element={<AuthOnly />}>
                        <Route path="/" element={<Decks />} />
                        <Route path="/new-deck" element={<NewDeck />} />
                        <Route path="/edit-deck/:deckId" element={<EditDeck />} />
                    </Route>
                </Routes>
            </BrowserRouter>
		</>
    );
}

export default App;
