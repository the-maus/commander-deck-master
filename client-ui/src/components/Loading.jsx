import React from "react";
import { Container } from "react-bootstrap";

const Loading = () => {
    return (
        <Container
            fluid
            className="d-flex justify-content-center align-items-center mt-5"
        >
            <div className="overlay">
                <div class="spinner">
                    <div class="spinner1"></div>
                </div>
            </div>
        </Container>
    );
};

export default Loading;
